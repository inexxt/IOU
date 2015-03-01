//
//  HomeTableViewController.m
//  IOU
//
//  Created by Bandi Enkh-Amgalan on 3/1/15.
//  Copyright (c) 2015 a. All rights reserved.
//

#import "HomeTableViewController.h"
#import "AFNetworking.h"
#import <QuartzCore/QuartzCore.h>

@interface HomeTableViewController ()

@end

@implementation HomeTableViewController

@synthesize lentAmount;
@synthesize lentLabel;
@synthesize oweAmount;
@synthesize oweLabel;
@synthesize transactions;
@synthesize profile;
@synthesize accessToken;

- (void)viewDidLoad {    
    [super viewDidLoad];
    
    UIGraphicsBeginImageContext(self.view.frame.size);
    [[UIImage imageNamed:@"Background.jpg"] drawInRect:self.view.bounds];
    UIImage *image = UIGraphicsGetImageFromCurrentImageContext();
    UIGraphicsEndImageContext();
    self.view.backgroundColor = [UIColor colorWithPatternImage:image];
    
    // 1
    NSString *string = [NSString stringWithFormat:@"http://localhost/~bandi/IOU/index.php?ACTION=AUTH&ACCESSTOKEN=%@", self.accessToken];
    NSURL *url = [NSURL URLWithString:string];
    NSURLRequest *request = [NSURLRequest requestWithURL:url];
    
    // 2
    AFHTTPRequestOperation *operation = [[AFHTTPRequestOperation alloc] initWithRequest:request];
    operation.responseSerializer = [AFJSONResponseSerializer serializer];
    
    [operation setCompletionBlockWithSuccess:^(AFHTTPRequestOperation *operation, id responseObject) {
        
        // 3
        self.profile = [(NSArray *)responseObject objectAtIndex:0];
        self.transactions = [(NSArray *)responseObject objectAtIndex:1];
        self.title = [self.profile objectForKey:@"name"];
        [self.tableView reloadData];
        
    } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
        
        // 4
        UIAlertView *alertView = [[UIAlertView alloc] initWithTitle:@"Error Retrieving Data"
                                                            message:[error localizedDescription]
                                                           delegate:nil
                                                  cancelButtonTitle:@"Ok"
                                                  otherButtonTitles:nil];
        [alertView show];
    }];
    
    // 5
    [operation start];
    
    // Uncomment the following line to preserve selection between presentations.
    // self.clearsSelectionOnViewWillAppear = NO;
    
    // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
    // self.navigationItem.rightBarButtonItem = self.editButtonItem;
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

#pragma mark - Table view data source

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView {
#warning Potentially incomplete method implementation.
    // Return the number of sections.
    if(self.profile == NULL || self.profile.count == 0)
        return 0;
    if(self.transactions == NULL || self.transactions.count == 0)
        return 1;
    return 2;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
#warning Incomplete method implementation.
    // Return the number of rows in the section.
    return section == 0 ? 2 : 5;
}


-(UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    UITableViewCell *cell;
    if(indexPath.section == 0)
    {
        if(indexPath.row == 0)
        {
            cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"c"];
            UIImageView *profilePicture = [[UIImageView alloc] initWithFrame:CGRectMake(tableView.bounds.size.width / 2.0 - 30, 10, 60, 60)];
            profilePicture.layer.backgroundColor = (__bridge CGColorRef)([UIColor clearColor]);
            profilePicture.layer.cornerRadius = 30;
            profilePicture.layer.masksToBounds = YES;
            profilePicture.tag = 0;
            [cell addSubview:profilePicture];
            
            UILabel *rating = [[UILabel alloc] initWithFrame:CGRectMake(0, 65, tableView.bounds.size.width, 15)];
            rating.text = [self.profile objectForKey:@"rating"];
            
            // 1
            NSString *string = [NSString stringWithFormat:@"http://graph.facebook.com/%@/picture", [self.profile objectForKey:@"UID"]];
            NSLog(string);
            NSURL *url = [NSURL URLWithString:string];
            
            NSURLRequest *request = [NSURLRequest requestWithURL:url];
            AFHTTPRequestOperation *operation = [[AFHTTPRequestOperation alloc] initWithRequest:request];
            operation.responseSerializer = [AFImageResponseSerializer serializer];
            [operation setCompletionBlockWithSuccess:^(AFHTTPRequestOperation *operation, id responseObject) {
                // 3
                profilePicture.image = responseObject;
            } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
                // 4
                UIAlertView *alertView = [[UIAlertView alloc] initWithTitle:@"Error Retrieving Data"
                                                                    message:[error localizedDescription]
                                                                   delegate:nil
                                                          cancelButtonTitle:@"Ok"
                                                          otherButtonTitles:nil];
                [alertView show];
            }];
                                                                                                    
            // 5
            [operation start];
            
            cell.backgroundColor = [UIColor clearColor];
        }
        else
        {
            cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@""];
            cell.selectionStyle = UITableViewCellSelectionStyleNone;
            if(self.oweLabel == NULL)
            {
                self.oweLabel = [[UILabel alloc] initWithFrame:CGRectMake(10, 20, (tableView.bounds.size.width - 20) / 2.0, 30)];
                [self.oweLabel setText:@"You Owe"];
                [self.oweLabel setTextAlignment:NSTextAlignmentCenter];
                [self.oweLabel setFont:[UIFont systemFontOfSize:30]];
                [self.oweLabel setTextColor:[UIColor redColor]];
            }
            if(self.lentLabel == NULL)
            {
                self.lentLabel = [[UILabel alloc] initWithFrame:CGRectMake(10 + (tableView.bounds.size.width - 20) / 2.0 + 10, 20, (tableView.bounds.size.width - 20) / 2.0, 30)];
                [self.lentLabel setText:@"You Lent"];
                [self.lentLabel setTextAlignment:NSTextAlignmentCenter];
                [self.lentLabel setFont:[UIFont systemFontOfSize:30]];
                [self.lentLabel setTextColor:[UIColor greenColor]];
            }
            if(self.oweAmount == NULL)
            {
                self.oweAmount = [[UILabel alloc] initWithFrame:CGRectMake(10, 60, (tableView.bounds.size.width - 20) / 2.0, 20)];
                [self.oweAmount setTextAlignment:NSTextAlignmentCenter];
                [self.oweAmount setFont:[UIFont systemFontOfSize:15]];
                [self.oweAmount setTextColor:[UIColor redColor]];
            }
            if(self.lentAmount == NULL)
            {
                self.lentAmount = [[UILabel alloc] initWithFrame:CGRectMake(10 + (tableView.bounds.size.width - 20) / 2.0 + 10, 60, (tableView.bounds.size.width - 20) / 2.0, 20)];
                [self.lentAmount setTextAlignment:NSTextAlignmentCenter];
                [self.lentAmount setFont:[UIFont systemFontOfSize:15]];
                [self.lentAmount setTextColor:[UIColor greenColor]];
            }
            
            [self.oweAmount setText:[NSString stringWithFormat:@"$%@", [self.profile objectForKey:@"totalBorrowed"]]];
            [self.lentAmount setText:[NSString stringWithFormat:@"$%@", [self.profile objectForKey:@"totalLent"]]];
            [cell addSubview:self.oweLabel];
            [cell addSubview:self.lentLabel];
            [cell addSubview:self.oweAmount];
            [cell addSubview:self.lentAmount];
            cell.backgroundColor = [UIColor clearColor];
        }
    }
    else
    {
        cell = [tableView dequeueReusableCellWithIdentifier:@"b"];
        UIImageView *profilePicture;
        UILabel *name;
        UILabel *subtext;
        if (cell == nil)
        {
            cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:@"b"];
            profilePicture = [[UIImageView alloc] initWithFrame:CGRectMake(10, 10, 50, 50)];
            profilePicture.layer.backgroundColor = (__bridge CGColorRef)([UIColor clearColor]);
            profilePicture.layer.cornerRadius = 25;
            profilePicture.layer.masksToBounds = YES;
            profilePicture.tag = 0;
            [cell addSubview:profilePicture];
            
            name = [[UILabel alloc] initWithFrame:CGRectMake(70, 0, tableView.bounds.size.width / 2.0, 50)];
            [name setFont:[UIFont systemFontOfSize:25]];
            name.tag = 1;
            [cell addSubview:name];
            
            subtext = [[UILabel alloc] initWithFrame:CGRectMake(70, 40, tableView.bounds.size.width / 2.0, 20)];
            [subtext setTextColor:[UIColor greenColor]];
            [subtext setFont:[UIFont systemFontOfSize:15]];
            subtext.tag = 2;
            [cell addSubview:subtext];
        }
        else
        {
            for(UIView *view in cell.subviews)
            {
                switch(view.tag)
                {
                    case 0:
                        profilePicture = view;
                        break;
                    case 1:
                        name = view;
                        break;
                    case 2:
                        subtext = view;
                        break;
                }
            }
        }
        
        [profilePicture setImage:[UIImage imageNamed:@"profile.jpg"]];
        [name setText:@"John Smith"];
        [subtext setText:@"lent you $0"];
        cell.selectionStyle = UITableViewCellSelectionStyleBlue;
        cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
    }
    
    // Configure the cell...
    
    return cell;
}


-(CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    return indexPath.section == 0 ? 100 : 70;
}

/*
// Override to support conditional editing of the table view.
- (BOOL)tableView:(UITableView *)tableView canEditRowAtIndexPath:(NSIndexPath *)indexPath {
    // Return NO if you do not want the specified item to be editable.
    return YES;
}
*/

/*
// Override to support editing the table view.
- (void)tableView:(UITableView *)tableView commitEditingStyle:(UITableViewCellEditingStyle)editingStyle forRowAtIndexPath:(NSIndexPath *)indexPath {
    if (editingStyle == UITableViewCellEditingStyleDelete) {
        // Delete the row from the data source
        [tableView deleteRowsAtIndexPaths:@[indexPath] withRowAnimation:UITableViewRowAnimationFade];
    } else if (editingStyle == UITableViewCellEditingStyleInsert) {
        // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view
    }   
}
*/

/*
// Override to support rearranging the table view.
- (void)tableView:(UITableView *)tableView moveRowAtIndexPath:(NSIndexPath *)fromIndexPath toIndexPath:(NSIndexPath *)toIndexPath {
}
*/

/*
// Override to support conditional rearranging of the table view.
- (BOOL)tableView:(UITableView *)tableView canMoveRowAtIndexPath:(NSIndexPath *)indexPath {
    // Return NO if you do not want the item to be re-orderable.
    return YES;
}
*/

/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/

@end
